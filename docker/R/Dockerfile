# Using a fixed version R to ensure consistency
FROM r-base:4.0.3
# Install system dependencies
RUN apt-get update --fix-missing && apt-get install -y \
    libmariadb-dev \
    libssl-dev

# Deps for curl and image-magick
RUN apt-get install -y \
    libcurl4-openssl-dev \
    libmagick++-dev

# Structural dependencies for notaR
RUN install.r curl

RUN install.r Rserve \
    RSclient \
    RMySQL

# Packages used in exercises
RUN install.r bbmle \
    png \
    Rsampling \
    magick \
    EcoVirtual

# Copies the required files for notaR
RUN mkdir -p /usr/local/src/notar
COPY . /usr/local/src/notar
WORKDIR /usr/local/src/notar

# We will listen on 6311
EXPOSE 6311

# Run the Rserve library:
CMD R --vanilla -e "library(Rserve);" -e "run.Rserve(remote=TRUE);"
