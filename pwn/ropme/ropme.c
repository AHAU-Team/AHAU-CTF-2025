#include <stdio.h>
#include <unistd.h>

void init() {
    setvbuf(stdin, 0, 2, 0);
    setvbuf(stdout, 0, 2, 0);
    setvbuf(stderr, 0, 2, 0);

    alarm(60);
}

char *get_name(char *name) {
    printf("Input your name: ");
    fgets(name, 256, stdin);
}

void usefulGadgets() {
    __asm__(
        ".intel_syntax noprefix\n"
        "endbr64; push rbp; mov rbp, rsp; sub rsp, 0x20;"
        "pop rax; pop rbp; ret;"
        "sal edx, 0xf; sub al, 0xd;"
        "sal eax, 0xd; pop rbx; ret;"
        "shr al, 0xd;"
        "mov rdi, rbx; ret;"
        "inc ebx; add rax, rcx;"
        "mov [rdx], rax; ret;"
        "add rcx, rdx; ret;"
        "mov rsi, rax; ret;"
        "call rsi;"
        "xchg r8, rax; ret;"
        "syscall; ret;"
        "pop rdx; ret;"
        "nop; leave; ret;"
        ".att_syntax prefix"
    );
}


int main() {
    init();
    puts(" ____________________________\n<    ROP me, if you can...   >\n ----------------------------\n        \     /\_/\\\n         \   ( o.o )\n             > ^ <\n");

    char name[64];
    get_name(name);
}
