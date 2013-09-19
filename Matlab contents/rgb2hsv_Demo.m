function rgb2hsv()
%fName = 'output3.txt';
% f = fopen(fName,'a');
% Change the current folder to the folder of this m-file.
if(~isdeployed)
cd(fileparts(which(mfilename)));
end
clc;	% Clear command window.
clear;	% Delete all variables.
close all;	% Close all figure windows except those created by imtool.
imtool close all;	% Close all figure windows created by imtool.
workspace;	% Make sure the workspace panel is showing.
fontSize = 20;

try
% Read in standard MATLAB color demo images.
imagesFolder = 'C:\Users\Sakti Aishwarya\Documents\MATLAB\';
if ~exist(imagesFolder, 'dir')
 	message = sprintf('Please browse to your image folder');
button = questdlg(message, 'Specify Folder', 'OK', 'Cancel', 'OK');
drawnow;	% Refresh screen to get rid of dialog box remnants.
if strcmpi(button, 'Cancel')
return;
else
imagesFolder = uigetdir();
if imagesFolder == 0
return;
end
end
end

% Read the directory to get a list of images.
filePattern = [imagesFolder, '\*.jpg'];
jpegFiles = dir(filePattern);
filePattern = [imagesFolder, '\*.tif'];
tifFiles = dir(filePattern);
filePattern = [imagesFolder, '\*.png'];
pngFiles = dir(filePattern);
filePattern = [imagesFolder, '\*.bmp'];
bmpFiles = dir(filePattern);
imageFiles = [jpegFiles; tifFiles; pngFiles; bmpFiles];

% Bail out if there aren't any images in that folder.
numberOfImagesProcessed = 0;
numberOfImagesToProcess = length(imageFiles);
if numberOfImagesToProcess <= 0
 	message = sprintf('I did not find any JPG, TIF, PNG, or BMP images in the folder\n%s\nClick OK to Exit.', imagesFolder);
uiwait(msgbox(message));
return;
end

% Create a figure for our images.
figure;
set(gcf, 'Position', get(0,'Screensize')); % Maximize figure.
set(gcf,'name','Demo by ImageAnalyst','numbertitle','off')

% Preallocate arrays to hold the means of all the images.
hImage_Mean = zeros(numberOfImagesToProcess, 1);
sImage_Mean = zeros(numberOfImagesToProcess, 1);
vImage_Mean = zeros(numberOfImagesToProcess, 1);
% Loop though all images, converting to hsv
% and then getting the means of the h, s, and v channels.
for k = 1 : numberOfImagesToProcess
    close all;
    clc;
% Read in this one file.
baseFileName = imageFiles(k).name;
fullFileName = fullfile(imagesFolder, baseFileName);
rgbImage = imread(fullFileName);
[rows columns numberOfColorBands] = size(rgbImage);
if numberOfColorBands <= 1
% Skip monochrome or indexed images.
continue;
end
subplot(3, 3, 1);
imshow(rgbImage, []);
[rows columns numberOfColorBands] = size(rgbImage);
caption = sprintf('Original Color Image\n%s\n%d rows by %d columns by%d color channels',baseFileName, rows, columns, numberOfColorBands);
% If there are underlines in the name, title() converts the next character to a subscript.
% To avoid this, replace underlines by spaces.
caption = strrep(caption, '_', ' ');
title(caption, 'FontSize', fontSize);
%drawnow; % Force it to update, otherwise it waits until after theconversion to double.

% Convert to floating point so it does the calculations correctly.
% Also needs to be normalized to 0-1.
rgbFloating = double(rgbImage) / 255.0;

% Compute hsv image
hsvImage = rgb2hsv(rgbFloating);
% H image:
hImage = hsvImage(:,:,1);
subplot(3, 3, 4);
imshow(hImage, []); % Display the image.
% Compute mean
hImage_Mean(k) = mean(hImage(:));
caption = sprintf('Hue Image. Mean = %6.2f', hImage_Mean(k));
title(caption, 'FontSize', fontSize);
% Compute and display the histogram for the H image.
histogramDouble(hImage, 7, 'Histogram of Hue Image');

% S image:
sImage = hsvImage(:,:,2);
subplot(3, 3, 5);
imshow(sImage, []); % Display the image.
% Compute mean
sImage_Mean(k) = mean(sImage(:));
caption = sprintf('Saturation Image. Mean = %6.2f', sImage_Mean(k));
title(caption, 'FontSize', fontSize);
% Compute and display the histogram for the S image.
histogramDouble(sImage, 8, 'Histogram of Saturation Image');

% V image:
vImage = hsvImage(:,:,3);
imshow(hImage);
imshow(sImage);
imshow(vImage);
subplot(3, 3, 6);
imshow(vImage, []); % Display the image.
numberOfImagesProcessed = numberOfImagesProcessed + 1;
% Compute mean
vImage_Mean(k) = mean(vImage(:));
caption = sprintf('Value Image. Mean = %6.2f', vImage_Mean(k));
title(caption, 'FontSize', fontSize);
% Compute and display the histogram for the V image.
histogramDouble(vImage, 9, 'Histogram of Value Image');

% Prompt user to continue, unless they're at the last image.

end
% Crop off any unassigned values:
hImage_Mean = hImage_Mean(1:numberOfImagesProcessed);
sImage_Mean = sImage_Mean(1:numberOfImagesProcessed);
vImage_Mean = vImage_Mean(1:numberOfImagesProcessed);

% Print to command window
%fprintf(1, ' Filename, H Mean, S Mean, V Mean\n');
for k = 1 : length(hImage_Mean)
baseFileName = imageFiles(k).name;
fprintf(1, 'Update`Properties_new` SET `hmean` = ''%6.2f'',`smean` = ''%6.2f'',`vmean`= ''%6.2f''where `Productname` = ''%24s'';\n', ...
hImage_Mean(k), sImage_Mean(k), vImage_Mean(k),baseFileName);
%fprintf(f, 'Insert into `Properties` (`hmean`,`smean`,`vmean`) VALUES (''%6.2f'', ''%6.2f'', ''%6.2f'') where `Productname`=''%24s''; \n', hImage_Mean(k), sImage_Mean(k), vImage_Mean(k),baseFileName);
   
end

if numberOfImagesProcessed == 1
caption = sprintf('Done with demo!\n\nProcessed 1 image.\nCheck outthe command window for the results');
else
caption = sprintf('Done with demo!\n\nProcessed %d images.\nCheck outthe command window for the results', numberOfImagesProcessed);
end
msgbox(caption);
catch ME
errorMessage = sprintf('Error in function rgb2hsv_demo.\nPerhaps theimage is too large.\n\nError Message:\n%s', ME.message);
uiwait(warndlg(errorMessage));

end
%fclose(f);

function histogramDouble(dblImage, subplotNumber, caption)
% So now we have a double image that is our "starting image."
% However can't use imhist on this. We need to scale to 0-1.
minValue = min(min(dblImage));
maxValue = max(max(dblImage));
range = maxValue - minValue;
dblImage = (dblImage - minValue) / range;
% Check to verify that range is now 0-1.
% minValueNorm = min(min(dblImage));
% maxValueNorm = max(max(dblImage));

% Let's get its histogram into 256 bins.
[pixelCount grayLevels] = imhist(dblImage, 256);

% Let's suppress the zero bin because it's always so high.
pixelCount(1) = 0;

% But now grayLevelsD goes from 0 to 1.
% We want it to go from the original range, so we need to scale.
originalDoubleGrayLevels = range * grayLevels + minValue;

subplot(3, 3, subplotNumber);
%plot(originalDoubleGrayLevels, pixelCount);
%title(caption, 'FontSize', 16);
% Scale x axis manually.
xlim([originalDoubleGrayLevels(1) originalDoubleGrayLevels(end)]);
return;

