function  [xa2 xb2 xc2 xd2 xe2 xf2 xg2 xh2 xi2 xj2 xk2 xl2 xm2] = nonkstest(nonbaseFileName,nonfeaturesFolder,c)
baseFileName=      nonbaseFileName;  
featuresFolder=nonfeaturesFolder;

            %s=d;
          % ab=  strcat(s,'.m');
           %display(ab);
% disp('testtttt111');       
           fullFileName = fullfile(featuresFolder, baseFileName);
           fid1 = fopen(fullFileName,'r');
       
        if(fid1<0)
            disp(fid1);
        end;
           
        b=linecount(fullFileName);
        %display(b);
        a=zeros(c,b);

        len=c*b;
        %display(len);
        for j = 1: len
                %if j == 5
                      x=fscanf(fid1,'%f',1);
                    %  fprintf(1,'%f ',x);
                      a(j)=x;     
                %end;
            
        end;
        fclose(fid1);
         xa2=a(1,:);
        xb2=a(2,:);
        xc2=a(3,:);
        xd2=a(4,:);
        xe2=a(5,:);
        xf2=a(6,:);
        xg2=a(7,:);
        xh2=a(8,:);
        xi2=a(9,:);
        xj2=a(10,:);
        xk2=a(11,:);
        xl2=a(12,:);
        xm2=a(13,:);
        %display(a);
        %display(x2);      
       
