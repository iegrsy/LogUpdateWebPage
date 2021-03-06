
package main

import (
"fmt"
"net/http"
"os"
"time"
"strings"
"bufio"
)

const MYFILE = "enerjirep1.txt"
const LOCALHOST = "http://iegrsy.space/fatura/index.php"
var HOST string = ""

func main() {
	args := os.Args[1:]
	fmt.Println(args)
	
	if len(args) > 0 {
		if args[0] != "" {
			HOST = args[0]
		}
	} else {
		HOST = LOCALHOST
	}

	c := time.Tick(3 * time.Second)
	for _ = range c {
		readLine(MYFILE)
	}
}

func readLine(path string) {
	inFile, _ := os.Open(path)
	defer inFile.Close()
	scanner := bufio.NewScanner(inFile)
	scanner.Split(bufio.ScanLines) 

	var lastline string = ""
	for scanner.Scan() {
		//fmt.Println(scanner.Text())
		lastline = scanner.Text()
	}
	fmt.Println(lastline)

	s := strings.Split(lastline, ",")

	ea := strings.Split(s[0], ":")
	ee := strings.Split(s[1], ":")
	ek := strings.Split(s[2], ":")
	iea := strings.Split(s[3], ":")
	iee := strings.Split(s[4], ":")
	iek := strings.Split(s[5], ":")

	fmt.Println(" 1: "+ ea[1])
	fmt.Println(" 1: "+ ee[1])
	fmt.Println(" 1: "+ ek[1])
	fmt.Println(" 1: "+ iea[1])
	fmt.Println(" 1: "+ iee[1])
	fmt.Println(" 1: "+ iek[1])

	var murl string = HOST + "?" + "ea=" + strings.TrimSpace(ea[1]) + "&ee=" + strings.TrimSpace(ee[1]) + "&ek=" + strings.TrimSpace(ek[1]) + "&iea=" + strings.TrimSpace(iea[1]) + "&iee=" + strings.TrimSpace(iee[1]) + "&iek=" + strings.TrimSpace(iek[1])
	fmt.Println(murl)
	a, _ := http.Get(murl)
	fmt.Println(a)
}