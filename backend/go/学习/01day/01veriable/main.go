package main

import (
	"fmt"
)

// 变量的声明方式
func main() {
	// 第一种
	// var 变量名称 数据类型 = 变量值
	var a bool = true
	// 如果不赋值，使用的是该数据类型的默认值。
	// 如果不赋值，采用各类型的默认值
	var b bool
	fmt.Println(a)
	fmt.Println(b)

	// 第二种
	// var 变量名称 = 变量值
	var c = true
	fmt.Println(c)

	// 第三种
	// 变量名称 := 变量值
	d := true
	fmt.Println(d)

	// 多个变量声明
	// 第一种：var 变量名称,变量名称 ... ,数据类型 = 变量值,变量值 ...
	var m, n bool = true, true
	fmt.Println(m)
	fmt.Println(n)

	// 第二种：var 变量名称,变量名称 ... = 变量值,变量值 ...
	var p, q = true, true
	fmt.Println(p)
	fmt.Println(q)

	// 第三种：变量名称,变量名称 ... := 变量值,变量值 ...
	h, j := true, true
	fmt.Println(h)
	fmt.Println(j)
}
