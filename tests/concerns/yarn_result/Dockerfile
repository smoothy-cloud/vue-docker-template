FROM node:alpine as build-stage

WORKDIR /app

COPY code-repository/package*.json code-repository/yarn.* /app/
RUN yarn install --silent

COPY code-repository/. /app/
RUN yarn run build
RUN yarn run build

FROM smoothy/nginx-1.18:1.0.0

COPY server.conf /etc/nginx/conf.d/server.conf
COPY --from=build-stage /app/dist /usr/share/nginx/html

