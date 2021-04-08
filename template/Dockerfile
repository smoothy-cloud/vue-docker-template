FROM node as build-stage

WORKDIR /app

{% if variable.package_manager == "npm" %}
COPY code-repository/package*.json /app/
RUN npm install --silent
{% elseif variable.package_manager == "yarn" %}
COPY code-repository/package*.json code-repository/yarn.* /app/
RUN yarn install --silent
{% endif %}

COPY code-repository/. /app/
{% for command in variable.build_script|trim|split('\n') %}
RUN {{ command }}
{% endfor %}

FROM smoothy/nginx-1.18:1.0.0

COPY server.conf /etc/nginx/conf.d/server.conf
COPY --from=build-stage /app/dist /usr/share/nginx/html
