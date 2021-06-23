# 自建 DNS 服务器


### Install
```sh
# 查看 bind 是否安装
> rpm -qa |grep bind
bind-license-9.11.4-26.P2.el7_9.5.noarch
bind-export-libs-9.11.4-26.P2.el7_9.5.x86_64
bind-libs-lite-9.11.4-26.P2.el7_9.5.x86_64

# 安装 bind
> yum install bind

# 再次查看
> rpm -qa |grep bind
bind-9.11.4-26.P2.el7_9.5.x86_64 # 安装成功
bind-license-9.11.4-26.P2.el7_9.5.noarch
bind-export-libs-9.11.4-26.P2.el7_9.5.x86_64
bind-libs-lite-9.11.4-26.P2.el7_9.5.x86_64
bind-libs-9.11.4-26.P2.el7_9.5.x86_64

# 启动、开机自启动
> systemctl start named
> systemctl enable named

# 测试域名解析
> nslookup www.baidu.com
# 如果没有 nslookup 命令，安装 bind-utils 套件
> yum install bind-utils
```

### 配置文件

```ini
//
// named.conf
//
// Provided by Red Hat bind package to configure the ISC BIND named(8) DNS
// server as a caching only nameserver (as a localhost DNS resolver only).
//
// See /usr/share/doc/bind*/sample/ for example named configuration files.
//
// See the BIND Administrator's Reference Manual (ARM) for details about the
// configuration located in /usr/share/doc/bind-{version}/Bv9ARM.html

options {
	//listen-on port 53 { 127.0.0.1; };   # 服务监听端口
    listen-on port 53 { any; }; # 监听全部地址的 53 端口
	listen-on-v6 port 53 { ::1; };
	directory 	"/var/named";
	dump-file 	"/var/named/data/cache_dump.db";
	statistics-file "/var/named/data/named_stats.txt";
	memstatistics-file "/var/named/data/named_mem_stats.txt";
	recursing-file  "/var/named/data/named.recursing";
	secroots-file   "/var/named/data/named.secroots";
	//allow-query     { localhost; };
	allow-query     { localhost; }; # 允许所有客户端提出查询

	/* 
	 - If you are building an AUTHORITATIVE DNS server, do NOT enable recursion.
	 - If you are building a RECURSIVE (caching) DNS server, you need to enable 
	   recursion. 
	 - If your recursive DNS server has a public IP address, you MUST enable access 
	   control to limit queries to your legitimate users. Failing to do so will
	   cause your server to become part of large scale DNS amplification 
	   attacks. Implementing BCP38 within your network would greatly
	   reduce such attack surface 
	*/
	recursion yes;

	dnssec-enable yes;
	dnssec-validation yes;

	/* Path to ISC DLV key */
	bindkeys-file "/etc/named.root.key";

	managed-keys-directory "/var/named/dynamic";

	pid-file "/run/named/named.pid";
	session-keyfile "/run/named/session.key";
};

logging {
        channel default_debug {
                file "data/named.run";
                severity dynamic;
        };
};

zone "." IN {
	type hint;
	file "named.ca";
};

include "/etc/named.rfc1912.zones";
include "/etc/named.root.key";
```

### 例
```sh
> vi /etc/named.rfc1912.zones

```

// todo 没配置完成呢
