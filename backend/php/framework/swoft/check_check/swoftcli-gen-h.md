```sh
$ swoftcli gen -h
Generate some common application template classes

Group: gen (alias: generate)
Usage:
  swoftcli gen:COMMAND [--opt ...] [arg ...]

Global Options:
      --debug      Setting the application runtime debug level(0 - 4)
      --no-color   Disable color/ANSI for message output
  -h, --help       Display help message for application or command
  -V, --version    Display application version information

Commands:
  cli-command     Generate CLI command controller class(alias: cmd, command)
  crontab         Generate user cronTab task class(alias: task-crontab, taskCrontab)
  http-controller Generate HTTP controller class(alias: ctrl, http-ctrl)
  http-middleware Generate HTTP middleware class(alias: http-mdl, httpmdl, http-middle)
  listener        Generate an event listener class(alias: event-listener)
  process         Generate user custom process class(alias: proc)
  rpc-controller  Generate RPC service class(alias: rpcctrl, service, rpc-ctrl)
  rpc-middleware  Generate RPC middleware class(alias: rpcmdl, rpc-mdl, rpc-middle)
  task            Generate user task class
  tcp-controller  Generate TCP controller class(alias: tcpc, tcpctrl, tcp-ctrl)
  tcp-middleware  Generate TCP middleware class(alias: tcpmdl, tcp-mdl, tcp-middle)
  ws-controller   Generate WebSocket message controller class(alias: wsc, wsctrl, ws-ctrl)
  ws-middleware   Generate WebSocket middleware class(alias: wsmdl, ws-mdl, ws-middle)
  ws-module       Generate WebSocket module class(alias: wsm, wsmod, ws-mod, wsModule)

View the specified command, please use: swoftcli gen:COMMAND -h
```