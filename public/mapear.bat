echo off
cls
echo called me!

net use lpt1: /delete
net use lpt1: \\Recebimento\Epson 
pause

