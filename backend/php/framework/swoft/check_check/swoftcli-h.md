```sh
$ php swoftcli.phar -h

🛠️ Command line tool application for quick use swoft (Version:  0.1.3)

Usage:
  swoftcli.phar COMMAND [arg0 arg1 arg2 ...] [--opt -v -h ...]

Options:
      --debug      Setting the application runtime debug level(0 - 4)
      --no-color   Disable color/ANSI for message output
  -h, --help       Display this help message
  -V, --version    Show application version information
      --expand     Expand sub-commands for all command groups

Available Commands:
  client         Provide some commands for quick connect tcp, ws server
  gen            Generate some common application template classes(alias: generate)
  new            Provide some commads for quick create new application or component(alias: create)
  phar           There are some command for help package application
  self-update    Update the swoft-cli to latest version from github(alias: selfupdate, update-self, updateself)
  serve          Provide some commands for manage and watch swoft server project
  system         Provide some system information commands[WIP](alias: sys)
  tool           Some internal tool commands, like ab, update-self

More command information, please use: swoftcli.phar COMMAND -h
```