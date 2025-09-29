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
        "push rsp; ret;"
        ".att_syntax prefix"
    );
}

int main() {
    init();
    puts(" ____________________________\n<    Pwn me, if you can...   >\n ----------------------------\n        \     /\_/\\\n         \   ( o.o )\n             > ^ <\n");

    char name[64];
    get_name(name);
}
