featuresFolder = 'C:\Users\Sakti Aishwarya\Documents\MATLAB\Keyword1';
nonfeaturesFolder=  'C:\Users\Sakti Aishwarya\Documents\MATLAB\NoKeyword1';

filePattern = [featuresFolder, '\*.txt'];
textFiles = dir(filePattern);
numberOffilesToProcess = length(textFiles);

nonfilePattern=[nonfeaturesFolder,'\*.txt'];
nontextFiles=dir(nonfilePattern);
nonnumberOffilesToProcess = length(nontextFiles);
completepath='C:\Users\Sakti Aishwarya\Documents\MATLAB\Keyword.txt';
noncompletepath='nonkeyword.txt';
k=0;
fid = fopen(completepath,'r');
wid= fopen('outputpvalues.txt','a');
%c=4; %rows
c=13; %columns
%a=zeros(6,c);
% nonfid = fopen(noncompletepath,'r'); 
%# Open the file
while( k <16720) %character array
     d=fscanf(fid,'%s',1);
 %   nond=fscanf(nonfid,'%s',1);
    %display(d);
       % fi=d;
    for i = 1 :  numberOffilesToProcess 
        
        baseFileName = textFiles(i).name;
        %display(baseFileName);
        [path name ext]=fileparts(baseFileName);
        %display(name);
        if(strcmp(name,d))
          %display('inside');
        fileappend=strcat(d,'noword.txt');
        nond=strcat(d,'noword');
        for j =1: nonnumberOffilesToProcess
        nonbaseFileName=nontextFiles(j).name;
        %display(nonbaseFileName);
        [path name1 ext]=fileparts(nonbaseFileName);
        if(strcmp(nonbaseFileName,fileappend))
         %   display(name1);
            %disp('inside');
             [xa1 xb1 xc1 xd1 xe1 xf1 xg1 xh1 xi1 xj1 xk1 xl1 xm1]= kstest(baseFileName,featuresFolder,c);
        
        [xa2 xb2 xc2 xd2 xe2 xf2 xg2 xh2 xi2 xj2 xk2 xl2 xm2]=nonkstest(nonbaseFileName,nonfeaturesFolder,c);
        
        [h pa] =kstest2(xa1,xa2);
         [h pb] =kstest2(xb1,xb2);
          [h pc] =kstest2(xc1,xc2);
           [h pd] =kstest2(xd1,xd2);
            [h pe] =kstest2(xe1,xe2);
             [h pf] =kstest2(xf1,xf2);
              [h pg] =kstest2(xg1,xg2);
               [h ph] =kstest2(xh1,xh2);
                [h pi] =kstest2(xi1,xi2);
                 [h pj] =kstest2(xj1,xj2);
                  [h pk] =kstest2(xk1,xk2);
                   [h pl] =kstest2(xl1,xl2);
                    [h pm] =kstest2(xm1,xm2);
       
        end
        xa2=0;
        end
     %   display(x1);
      %  display(x2);
        fprintf(1,'Insert into `pvalue` (`keyword`,`Tcoarsenessp`,`TContrastp`,`TDirectionp`,`Correlationp`,`Contrastp`,`Energyp`,`Homogeneityp`,`imgsump`,`imgavgp`,`imgstdp`,`hmeanp`,`smeanp`,`vmeanp`)VALUES (''%s'',''%f'',''%f'',''%f'',''%f'',''%f'',''%f'',''%f'',''%f'' ''%f'',''%f'', ''%f'',''%f'',''%f'',''%f''); \n',name,pa,pb,pc,pd,pe,pf,pg,ph,pi,pj,pk,pl,pm);
       
        end
      
    end
    
k=k+1;    
end

