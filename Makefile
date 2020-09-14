package = click2call
prefix = /usr
datadir = $(prefix)/share
main_dir = $(datadir)/$(package)
apache_dir = /etc/httpd/conf.d

all: install

install:
	#Configure Apache
	ln -sf $(main_dir)/apache/click2call.conf $(apache_dir)/

	#Restart Apache
	systemctl reload-or-restart httpd.service

.PHONY: all install