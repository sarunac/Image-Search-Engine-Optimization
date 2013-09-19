imagesFolder = 'C:\Users\Sakti Aishwarya\Documents\MATLAB\images3';
if ~exist(imagesFolder, 'dir')
 	message = sprintf('Please browse to your image folder');
button = questdlg(message, 'Specify Folder', 'OK', 'Cancel', 'OK');
drawnow;	% Refresh screen to get rid of dialog box remnants.
fName = 'output1.txt';
fidnew = fopen(fname,'a');
if strcmpi(button, 'Cancel')
return;
else
imagesFolder = uigetdir();
if imagesFolder == 0
return;
end
end
end
filePattern = [imagesFolder, '\*.tif'];
tifFiles = dir(filePattern);
imageFiles = tifFiles;
numberOfImagesToProcess = length(imageFiles);
numberOfImagesProcessed = 0;
for k = 1 : numberOfImagesToProcess
% Read in this one file.
%display(k);
baseFileName = imageFiles(k).name;
fullFileName = fullfile(imagesFolder, baseFileName);
i = imread(fullFileName);
[cor con homo energy tcor tcon tdir] = generate_skinmap(i);
[imgsum,imgavg,imgstd,imgmin,imgmax] = imgstat(fullFileName);
fprintf(1, 'Insert into `Properties` (`Productname`,`Tcoarseness`,`TContrast`,`TDirection`,`Correlation`,`Contrast`,`Energy`,`Homogeneity`,`imgsum`,`imgavg`,`imgstd`,`imgmin`,`imgmax`) VALUES (''%s'',''%d'',''%d'',''%d'',''%d'',''%d'',''%d'',''%d'',''%f'',''%f'',''%f'',''%f'',''%f''); \n',baseFileName,tcor,tcon,tdir,con, cor,energy,homo,imgsum,imgavg,imgstd,imgmin,imgmax);
   
%imshow(i);

end
