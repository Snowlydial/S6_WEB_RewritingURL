# Start
```bash
docker compose up -d
```

# In case of big modifications (mostly logic)
```bash
docker compose restart app # the app is already mounted so the templates don't need to restart
```