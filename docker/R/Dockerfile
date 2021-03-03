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
RUN mkdir -p /usr/local/src/notar
COPY . /usr/local/src/notar
WORKDIR /usr/local/src/notar

# We will listen on 6311 
EXPOSE 6311

# Run the Rserve library:
CMD R --vanilla -e "library(Rserve);" -e "run.Rserve(remote=TRUE);"