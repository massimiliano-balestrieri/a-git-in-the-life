FROM nimmis/alpine-apache-php5 as base

RUN curl https://packages.zendframework.com/releases/ZendFramework-1.0.3/ZendFramework-1.0.3.tar.gz \
        --output /tmp/zend.tar.gz

WORKDIR /web/html/external
# RUN mkdir ./zend
RUN tar -xzvf /tmp/zend.tar.gz -C /web/html/external/

WORKDIR /web/html