# This should overwhelm any system

m <- matrix(1:1000,nrow=1)
while(TRUE)
  m <- rbind(m,m)
