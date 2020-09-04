FROM node:alpine as build-stage

WORKDIR /app

{% if variable.package_manager == "npm" %}
COPY code-repository/package*.json /app/
RUN npm install --silent
{% elseif variable.package_manager == "yarn" %}
COPY code-repository/package*.json code-repository/yarn.* /app/
RUN yarn install --silent
{% endif %}

COPY code-repository/. /app/
{% for command in variable.build_script %}
RUN {{ command }}
{% endfor %}

FROM nginx:1.18-alpine

COPY nginx.conf /etc/nginx/nginx.conf
COPY --from=build-stage /app/dist /usr/share/nginx/html

EXPOSE 80
WORKDIR /usr/share/nginx/html

CMD ["/usr/sbin/nginx", "-c", "/etc/nginx/nginx.conf"]
