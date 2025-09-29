FROM python:3.12-slim

ENV PYTHONDONTWRITEBYTECODE=1 \
    PYTHONUNBUFFERED=1

RUN useradd -m -u 10001 hacker

RUN apt-get update \
 && apt-get install -y --no-install-recommends gcc wget curl \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY requirements.txt /app/requirements.txt
RUN pip install --no-cache-dir -r requirements.txt

COPY src/ /app/src/
COPY flag.txt /home/hacker

RUN chown -R hacker:hacker /app
USER hacker

EXPOSE 8000

ENV WORKERS=2 \
    TIMEOUT=15

CMD ["sh", "-c", "gunicorn -w ${WORKERS} -b 0.0.0.0:8000 --timeout ${TIMEOUT} src.app:app"]
