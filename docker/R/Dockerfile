# Using a fixed version R to ensure consistency
FROM r-base:4.0.3
# Install system dependencies
RUN apt-get update && apt-get install -y \
    libmariadbclient-dev \
    libssl-dev
    
RUN install.r Rserve \
    RSclient \
    RMySQL \
    bbmle

# Copies the required files for notaR
#COPY . /usr/local/src/myscripts
#WORKDIR /usr/local/src/myscripts

# We will listen on 6311 
EXPOSE 6311

# Run the Rserve library:
CMD R --vanilla -e "library(Rserve);" -e "run.Rserve();"