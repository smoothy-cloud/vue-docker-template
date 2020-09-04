FROM node:alpine as build-stage

WORKDIR /app

COPY code-repository/package*.json code-repository/yarn.* /app/
RUN yarn install --silent

COPY code-repository/. /app/
RUN yarn run build

FROM nginx:1.18-alpine

COPY nginx.conf /etc/nginx/nginx.conf
COPY --from=build-stage /app/dist /usr/share/nginx/html

EXPOSE 80
WORKDIR /usr/share/nginx/html

CMD ["/usr/sbin/nginx", "-c", "/etc/nginx/nginx.conf"]
