
package main

import (
	"fmt"
	"net/http"
	//"io/ioutil"
	"os"
	"time"
	"strings"
	"bufio"
)

const MYFILE = "C:\\Users\\test\\Desktop\\enerjirep1.txt"

func main() {

	c := time.Tick(3 * time.Second)

	for _ = range c {
		//readFile(MYFILE)
		readLine(MYFILE)
	}
}

func readFile(fname string) {
	file, err := os.Open(fname)
    if err != nil {
        panic(err)
    }
    defer file.Close()

    buf := make([]byte, 51)
    stat, err := os.Stat(fname)
    start := stat.Size() - 51
    _, err = file.ReadAt(buf, start)
    if err == nil {
        //fmt.Printf("%s\n", buf)
    
    	s := strings.Split(string(buf), ",")
    	//fmt.Println(s)
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

    	var murl string = "http://192.168.1.27/test.php?" + "ea=" + strings.TrimSpace(ea[1]) + "&ee=" + strings.TrimSpace(ee[1]) + "&ke=" + strings.TrimSpace(ke[1]) + "&iea=" + strings.TrimSpace(iea[1]) + "&iee=" + strings.TrimSpace(iee[1]) + "&iek=" + strings.TrimSpace(iek[1])
    	fmt.Println(murl)
    a, _ := http.Get(murl)
	fmt.Println(a)
    }
}

func readLine(path string) {
  inFile, _ := os.Open(path)
  defer inFile.Close()
  scanner := bufio.NewScanner(inFile)
	scanner.Split(bufio.ScanLines) 
  
  for scanner.Scan() {
    fmt.Println(scanner.Text())
  }
}