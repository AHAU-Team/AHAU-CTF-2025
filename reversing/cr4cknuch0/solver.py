#!/usr/bin/env python
# coding: utf-8

import binascii


def main():
    flag = b""

    xor = 90
    hexblock1 = binascii.unhexlify("3625382146e14c8558131e815edf18531a6d701d46f1688d22")
    hexblock2 = binascii.unhexlify("4071510a7150584a4e0d5c0c577150095d63491d4e4b414f44")

    for idx, c in enumerate(hexblock1):
        flag += bytes(chr(int((int(c) - idx) / 2) ^ xor), "utf-8")

    for idx, c in enumerate(hexblock2):
        match idx % 3:
            case 0:
                flag += bytes(chr(int(c) ^ ord("c") ^ xor), "utf-8")
            case 1:
                flag += bytes(chr(int(c) ^ ord("t") ^ xor), "utf-8")
            case 2:
                flag += bytes(chr(int(c) ^ ord("f") ^ xor), "utf-8")

    return str(flag)


if __name__ == "__main__":
    print(main())
