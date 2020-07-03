for i in $(kubectl get secret db-secret -o json | jq -c '.data[]'); do echo $i | jq -r . | base64 -d; echo ""; done;
