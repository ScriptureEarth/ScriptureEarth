# Live preview server for database editors. See preview/README.md.
# Build from the astro/ folder:  docker build -f preview/Dockerfile -t se-preview .
FROM node:22-slim

ENV NODE_ENV=production \
    PORT=8080 \
    ASTRO_TELEMETRY_DISABLED=1 \
    COREPACK_ENABLE_DOWNLOAD_PROMPT=0
RUN corepack enable

WORKDIR /app
COPY package.json pnpm-lock.yaml pnpm-workspace.yaml ./
# Dev dependencies too: the extract step uses d3-geo (world map) at run time.
RUN pnpm install --frozen-lockfile --prod=false

COPY . .
# Each preview writes content/, dist/, .astro/ and public/search-index.txt here.
RUN chown -R node:node /app
USER node

EXPOSE 8080
HEALTHCHECK --interval=30s --timeout=5s CMD node -e "fetch('http://127.0.0.1:'+process.env.PORT+'/healthz').then(r=>process.exit(r.ok?0:1)).catch(()=>process.exit(1))"
CMD ["node", "preview/server.mjs"]
