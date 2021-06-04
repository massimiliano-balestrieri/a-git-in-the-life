FROM nimmis/alpine-apache-php5 as base
# FROM nimmis/apache:14.04 as base

RUN sed -i '/LoadModule rewrite_module/s/^#//g' /etc/apache2/httpd.conf

RUN curl https://packages.zendframework.com/releases/ZendFramework-1.0.3/ZendFramework-1.0.3.tar.gz \
        --output /tmp/zend.tar.gz

WORKDIR /web/html/external
# RUN mkdir ./zend
RUN tar -xzvf /tmp/zend.tar.gz -C /web/html/external/

WORKDIR /web/html

RUN mkdir -p /web/html/public
RUN mkdir -p /web/html/public/repository/smarty/cache
RUN mkdir -p /web/html/public/repository/smarty/templates_c
RUN chmod -R 777 /web/html/public
