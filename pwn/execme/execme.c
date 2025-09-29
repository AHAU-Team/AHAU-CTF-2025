#include <stdio.h>
#include <string.h>
#include <unistd.h>
#include <stdlib.h>

void init() {
    setvbuf(stdin, 0, 2, 0);
    setvbuf(stdout, 0, 2, 0);
    setvbuf(stderr, 0, 2, 0);

    alarm(60);
}


int validate(char *name, int size) {
    char badchars[] = "\x2f\x3b\x62\x66\x69\x6c\x6e\x61\x73\x67\x68";
    for (int i = 0; i < strlen(badchars); i++) {
        for (int j = 0; j < size; j++) {
            if (badchars[i] == name[j])
                return 0;
        }
    }
    return 1;
}

int main() {
    init();
    puts(" ____________________________\n<   Exec me, if you can...   >\n ----------------------------\n        \     /\_/\\\n         \   ( o.o )\n             > ^ <\n");
    printf("Input your name: ");

    char name[64];
    int size = read(0, name, 64);

    if (!validate(name, size)) {
        puts("You can'n exec me :p");
        exit(1);
    }

    ((void(*)())name)();
}
