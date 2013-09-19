%IMGSTAT Image statistics
%   Returns statistics of an image M, or a portion of it.
%   
%   Syntax
%   [sum,avg,std,min,max] = imgstat(M)
%   [sum,avg,std,min,max] = imgstat(M,'r')
%   [sum,avg,std,min,max] = imgstat(M,V)
%
%   Description
%   imgstat(M)
%       returns the stats of the matrix M.
% 
%   imgstat(M,'r')
%       displays M and lets you select a rectangle for the stats. To
%       constrain the rectangle to be a square, use a shift- or right-click
%       to begin the drag.
% 
%   imgstat(M,V)
%       returns the stats of a portion of M, defined by V.
%       V is a four-element vector with the form [xmin ymin width height],
%       with the origin being the upper-left corner of the image.

function [imgsum,imgavg,imgstd,imgmin,imgmax] = imgstat(M,rect)
%% Check arguments
% Check that number of input arguments is correct 
error(nargchk(1, 2, nargin))

% Check whether 2nd argument is present and of the correct value 
if (nargin == 2)
    roistr = 'selected rectangle';
    if (rect == 'r')
        % Display image
   %     imshow(M,[min(M(:)) max(M(:))]);

        % Get user to specify rectangle with mouse
        rect = round(getrect(gcf))

        % Crop image
        M = M(rect(2):rect(2)+rect(4),rect(1):rect(1)+rect(3));

        % Display cropped image
        delete(gcf);
     %   imshow(M,[min(M(:)) max(M(:))]);
    else
        % Check is 2nd argument is a valid vector
        if isvector(rect) && (length(rect) == 4) && isnumeric(rect)
            % Crop image
            M = M(rect(2):rect(2)+rect(4),rect(1):rect(1)+rect(3));
        else
            error('Second argument is incorrectly specified')
        end
    end
else
    roistr = 'complete image';
end

%% Compute stats
imgsum = sum(sum(M));
imgavg = mean2(M);
imgstd = std2(M);
imgmin = min(M(:));
imgmax = max(M(:));

%% Display stats if applicable
% User did not specify output arguments, so display the stats
if nargout == 0
    str = ['Statistics for the ' roistr sprintf(':\n') ...
           sprintf('Size:\t%ix%i pixels\n',size(M)) ...
           sprintf('Sum:\t%f counts\n', imgsum) ...
           sprintf('Mean:\t%f counts\n', imgavg) ...
           sprintf('StDev:\t%f counts\n', imgstd) ...
           sprintf('Min:\t%f counts\n', imgmin) ...
           sprintf('Max:\t%f counts\n', imgmax)];

    disp(str);
end