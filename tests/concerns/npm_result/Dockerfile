FROM node:alpine as build-stage

WORKDIR /app

COPY code-repository/package*.json /app/
RUN npm install --silent

COPY code-repository/. /app/
RUN npm run build
RUN npm run build

FROM smoothy/nginx-1.18:1.0.0

COPY server.conf /etc/nginx/conf.d/server.conf
COPY --from=build-stage /app/dist /usr/share/nginx/html

