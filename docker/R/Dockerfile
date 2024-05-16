# Using a fixed version R to ensure consistency
FROM r-base:4.4.0
# Install system dependencies
RUN apt-get update --fix-missing \
    && apt-get install -y --no-install-recommends \
    libmariadb-dev \
    libssl-dev \
# Structural dependencies for notaR
    r-cran-curl \
    r-cran-rserve \
    r-cran-rsclient \
    r-cran-rmysql \
    && rm -rf /var/lib/apt/lists/*


# Copies the required files for notaR
RUN mkdir -p /usr/local/src/notar
COPY . /usr/local/src/notar
WORKDIR /usr/local/src/notar

# Install packages used in exercises
RUN apt-get update --fix-missing \
    && apt-get install -y --no-install-recommends \
    r-cran-bbmle \
    r-cran-png \
    r-cran-magick \
    && rm -rf /var/lib/apt/lists/*

# Install packages used in exercises that aren't available in apt
RUN install2.r --error --skipinstalled --ncpus -1 \
    Rsampling \
    EcoVirtual \
    && rm -rf /tmp/downloaded_packages


# We will listen on 6311
EXPOSE 6311

# Run the Rserve library:
CMD R --vanilla -e "library(Rserve);" -e "run.Rserve(remote=TRUE);"
