
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
const HOST = "http://192.168.1.27/test.php"

func main() {

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
	ke := strings.Split(s[2], ":")
	iea := strings.Split(s[3], ":")
	iee := strings.Split(s[4], ":")
	iek := strings.Split(s[5], ":")

	fmt.Println(" 1: "+ ea[1])
	fmt.Println(" 1: "+ ee[1])
	fmt.Println(" 1: "+ ke[1])
	fmt.Println(" 1: "+ iea[1])
	fmt.Println(" 1: "+ iee[1])
	fmt.Println(" 1: "+ iek[1])

	var murl string = HOST + "?" + "ea=" + strings.TrimSpace(ea[1]) + "&ee=" + strings.TrimSpace(ee[1]) + "&ke=" + strings.TrimSpace(ke[1]) + "&iea=" + strings.TrimSpace(iea[1]) + "&iee=" + strings.TrimSpace(iee[1]) + "&iek=" + strings.TrimSpace(iek[1])
	fmt.Println(murl)
	a, _ := http.Get(murl)
	fmt.Println(a)
}