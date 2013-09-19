function  [xa1 xb1 xc1 xd1 xe1 xf1 xg1 xh1 xi1 xj1 xk1 xl1 xm1] = kstest(baseFileName,featuresFolder,c)
            
       
           fullFileName = fullfile(featuresFolder, baseFileName);
           fid1 = fopen(fullFileName,'r');
       
        if(fid1<0)
            disp(fid1);
        end;
           
        b=linecount(fullFileName);
        %display(b);
        a=zeros(c,b);

        j=0;
        
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
        xa1=a(1,:);
        xb1=a(2,:);
        xc1=a(3,:);
        xd1=a(4,:);
        xe1=a(5,:);
        xf1=a(6,:);
        xg1=a(7,:);
        xh1=a(8,:);
        xi1=a(9,:);
        xj1=a(10,:);
        xk1=a(11,:);
        xl1=a(12,:);
        xm1=a(13,:);
        
        %display(a);
        %display(x1);
  