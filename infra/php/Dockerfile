# https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4
# FROM命令はイメージビルドのためのベースイメージを設定。FROM イメージ名:タグ名
FROM php:7.4-fpm-buster

# SHELL命令は何も指定しない場合は SHELL ["/bin/sh", "-c"] がデフォルト値となる。
# -o オプションはオプションを設定するためのオプションです。
# -e そのシェルスクリプト内で何らかのエラーが発生した時点で、それ以降の処理を中断できます。
# -u 未定義の変数に対して読み込み等を行おうとした際にエラーとなります。
# -x 実行したコマンドを全て標準エラー出力に出してくれます。
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# ENV命令はコンテナ内のサーバー環境変数を設定します。
# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#env
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

# Dockerfile内で apt を実行するとCLIインターフェース向けではないと警告が表示されるため、apt-getを使用

# apt-get update インストール可能なパッケージの「一覧」を更新します。
# 実際のパッケージのインストール、アップグレードなどは行いません。
RUN apt-get update && \
  # apt-get -y install xxx Laravelのインストールに必要なパッケージをインストールします。
  apt-get -y install git unzip libpq-dev libzip-dev libicu-dev libonig-dev && \
  # apt-get clean && rm -rf /var/lib/apt/lists/* ここはパッケージインストールで使用したキャッシュファイルを削除しています。
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  # PHPの拡張ライブラリをインストールしています。
  docker-php-ext-install intl pdo_pgsql zip bcmath

# php.iniをコピー
# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#copy
COPY ./php.ini /usr/local/etc/php/php.ini

# npm導入
RUN apt-get -y update
RUN apt-get install -y \
    curl \
    gnupg
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

# ワークディレクトリを設定
# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#workdir
WORKDIR /work
