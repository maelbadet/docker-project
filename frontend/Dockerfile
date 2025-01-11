FROM node:18

WORKDIR /app
COPY package*.json ./

RUN npm install
RUN npm install react-router-dom
RUN npm install swiper
RUN npm i --save @fortawesome/fontawesome-svg-core

COPY . .
COPY ./img /app/public/img

EXPOSE 3000

CMD ["npm", "start"]
