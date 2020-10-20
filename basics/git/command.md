# 命令
基于 `version 1.8.3.1`

```sh
> git
usage: git [--version] [--help] [-c name=value]  
           [--exec-path[=<path>]] [--html-path] [--man-path] [--info-path]  
           [-p|--paginate|--no-pager] [--no-replace-objects] [--bare]  
           [--git-dir=<path>] [--work-tree=<path>] [--namespace=<name>]  
           <command> [<args>]

The most commonly used git commands are:  
   add        Add file contents to the index  
   bisect     Find by binary search the change that introduced a bug  
   branch     List, create, or delete branches  
   checkout   Checkout a branch or paths to the working tree  
   clone      Clone a repository into a new directory  
   commit     Record changes to the repository  
   diff       Show changes between commits, commit and working tree, etc  
   fetch      Download objects and refs from another repository  
   grep       Print lines matching a pattern  
   init       Create an empty Git repository or reinitialize an existing one  
   log        Show commit logs  
   merge      Join two or more development histories together  
   mv         Move or rename a file, a directory, or a symlink  
   pull       Fetch from and merge with another repository or a local branch  
   push       Update remote refs along with associated objects  
   rebase     Forward-port local commits to the updated upstream head  
   reset      Reset current HEAD to the specified state  
   rm         Remove files from the working tree and from the index  
   show       Show various types of objects  
   status     Show the working tree status  
   tag        Create, list, delete or verify a tag object signed with GPG  

'git help -a' and 'git help -g' lists available subcommands and some
concept guides. See 'git help <command>' or 'git help <concept>'
to read about a specific subcommand or concept.
```

## 选项

### `--version`
Prints the Git suite version that the git program came from.
> 打印 git 版本。

### `--help`
Prints the synopsis and a list of the most commonly used commands. If the option --all or -a is given then all available commands are printed. If a Git command is named this option will bring up the manual page for that command.
> 打印概要和常用命令如果给出选项 `--all` 或 `-a`，则将打印所有可用命令。

Other options are available to control how the manual page is displayed. See git-help[1] for more information, because git --help ... is converted internally into git help ....


// todo centos 自带版本过低，升级git后继续翻译
### `-C <path>`
Run as if git was started in <path> instead of the current working directory. When multiple -C options are given, each subsequent non-absolute -C <path> is interpreted relative to the preceding -C <path>. If <path> is present but empty, e.g. -C "", then the current working directory is left unchanged.

This option affects options that expect path name like --git-dir and --work-tree in that their interpretations of the path names would be made relative to the working directory caused by the -C option. For example the following invocations are equivalent:
> 用于修改 git 命令执行的目录，例如在桌面执行如下命令和进入到 `/foo` 文件夹中执行 `status` 一样

```sh
> git -C /foo status
```

### `-c <name>=<value>`
Pass a configuration parameter to the command. The value given will override values from configuration files. The <name> is expected in the same format as listed by git config (subkeys separated by dots).

Note that omitting the = in git -c foo.bar ... is allowed and sets foo.bar to the boolean true value (just like [foo]bar would in a config file). Including the equals but with an empty value (like git -c foo.bar= ...) sets foo.bar to the empty string which git config --type=bool will convert to false.

### `--exec-path[=<path>]`
Path to wherever your core Git programs are installed. This can also be controlled by setting the GIT_EXEC_PATH environment variable. If no path is given, git will print the current setting and then exit.

### `--html-path`
Print the path, without trailing slash, where Git’s HTML documentation is installed and exit.

### `--man-path`
Print the manpath (see man(1)) for the man pages for this version of Git and exit.

### `--info-path`
Print the path where the Info files documenting this version of Git are installed and exit.

### `-p`
`--paginate`  
Pipe all output into less (or if set, $PAGER) if standard output is a terminal. This overrides the pager.<cmd> configuration options (see the "Configuration Mechanism" section below).

### `-P`
--no-pager
Do not pipe Git output into a pager.

### `--git-dir=<path>`
Set the path to the repository (".git" directory). This can also be controlled by setting the GIT_DIR environment variable. It can be an absolute path or relative path to current working directory.  

Specifying the location of the ".git" directory using this option (or GIT_DIR environment variable) turns off the repository discovery that tries to find a directory with ".git" subdirectory (which is how the repository and the top-level of the working tree are discovered), and tells Git that you are at the top level of the working tree. If you are not at the top-level directory of the working tree, you should tell Git where the top-level of the working tree is, with the --work-tree=<path> option (or GIT_WORK_TREE environment variable)

If you just want to run git as if it was started in <path> then use git -C <path>.

### `--work-tree=<path>`
Set the path to the working tree. It can be an absolute path or a path relative to the current working directory. This can also be controlled by setting the GIT_WORK_TREE environment variable and the core.worktree configuration variable (see core.worktree in git-config[1] for a more detailed discussion).

### `--namespace=<path>`
Set the Git namespace. See gitnamespaces[7] for more details. Equivalent to setting the GIT_NAMESPACE environment variable.

### `--super-prefix=<path>`
Currently for internal use only. Set a prefix which gives a path from above a repository down to its root. One use is to give submodules context about the superproject that invoked it.

### `--bare`
Treat the repository as a bare repository. If GIT_DIR environment is not set, it is set to the current working directory.

### `--no-replace-objects`
Do not use replacement refs to replace Git objects. See git-replace[1] for more information.

### `--literal-pathspecs`
Treat pathspecs literally (i.e. no globbing, no pathspec magic). This is equivalent to setting the GIT_LITERAL_PATHSPECS environment variable to 1.

### `--glob-pathspecs`
Add "glob" magic to all pathspec. This is equivalent to setting the GIT_GLOB_PATHSPECS environment variable to 1. Disabling globbing on individual pathspecs can be done using pathspec magic ":(literal)"

### `--noglob-pathspecs`
Add "literal" magic to all pathspec. This is equivalent to setting the GIT_NOGLOB_PATHSPECS environment variable to 1. Enabling globbing on individual pathspecs can be done using pathspec magic ":(glob)"

### `--icase-pathspecs`
Add "icase" magic to all pathspec. This is equivalent to setting the GIT_ICASE_PATHSPECS environment variable to 1.

### `--no-optional-locks`
Do not perform optional operations that require locks. This is equivalent to setting the GIT_OPTIONAL_LOCKS to 0.

### `--list-cmds=group[,group…​]`
List commands by group. This is an internal/experimental option and may change or be removed in the future. Supported groups are: builtins, parseopt (builtin commands that use parse-options), main (all commands in libexec directory), others (all other commands in $PATH that have git- prefix), list-<category> (see categories in command-list.txt), nohelpers (exclude helper commands), alias and config (retrieve command list from config variable completion.commands)