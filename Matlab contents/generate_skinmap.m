function [cor con homo energy tcor tcon tdir] = generate_skinmap(filename)
%GENERATE_SKINMAP Produce a skinmap of a given image. Highlights patches of
%"skin" like pixels. Can be used in face detection, gesture recognition,
%and other HCI applications.

%   The function reads an image file given by the input parameter string
%   filename, read by the MATLAB function 'imread'.
%   out - contains the skinmap overlayed onto the image with skin pixels
%   marked in blue color.
%   bin - contains the binary skinmap, with skin pixels as '1'.
%
    
    if nargin > 1 | nargin < 1
        error('usage: generate_skinmap(filename)');
    end;
    
    %Read the image, and capture the dimensions
    img_orig = imread(filename);
    height = size(img_orig,1);
    width = size(img_orig,2);
    
    %Initialize the output images
    out = img_orig;
    bin = zeros(height,width);
    
    %Apply Grayworld Algorithm for illumination compensation
    img = grayworld(img_orig);    
    
    %Convert the image from RGB to YCbCr
    img_ycbcr = rgb2ycbcr(img);
    Cb = img_ycbcr(:,:,2);
    Cr = img_ycbcr(:,:,3);
    
    %Detect Skin
    [r,c,v] = find(Cb>=77 & Cb<=127 & Cr>=133 & Cr<=173);
    numind = size(r,1);
    
    %Mark Skin Pixels
    for i=1:numind
        out(r(i),c(i),:) = [0 0 255];
        bin(r(i),c(i)) = 1;
    end
    imshow(img_orig);
   figure; imshow(out);
    figure; imshow(bin);
       % figure;imagesc(bin);
   
    %extracting Tamura texture features
   %    Tamura(bin);
    %offsets0 = [zeros(40,1) (1:40)'];
   glcms = graycomatrix(bin);
   [m n] = size(glcms);
   for x= 1:m
       for y= 1:n
           stats = graycoprops(glcms , {'Contrast', 'Correlation', 'Energy', 'Homogeneity'});
       end
   end
   cor=stats.Correlation;
   con=stats.Contrast;
   energy=stats.Energy;
   homo=stats.Homogeneity;
   [tcor tcon tdir]=Tamura(bin);
   
  
   
end
function out = grayworld(I)
%Color Balancing using the Gray World Assumption
%   I - 24 bit RGB Image
%   out - Color Balanced 24-bit RGB Image


    out = uint8(zeros(size(I,1), size(I,2), size(I,3)));
    
    %R,G,B components of the input image
    R = I(:,:,1);
    G = I(:,:,2);
    B = I(:,:,3);

    %Inverse of the Avg values of the R,G,B
    mR = 1/(mean(mean(R)));
    mG = 1/(mean(mean(G)));
    mB = 1/(mean(mean(B)));
    
    %Smallest Avg Value (MAX because we are dealing with the inverses)
    maxRGB = max(max(mR, mG), mB);
    
    %Calculate the scaling factors
    mR = mR/maxRGB;
    mG = mG/maxRGB;
    mB = mB/maxRGB;
   
    %Scale the values
     out(:,:,1) = R*mR;
     out(:,:,2) = G*mG;
     out(:,:,3) = B*mB;
end