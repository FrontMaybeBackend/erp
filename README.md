# erp

First do you need to generate pair of keys RSA for JWT:
## private key
```  openssl genpkey -algorithm RSA -out private.pem -pkeyopt rsa_keygen_bits:2048 ```

## public key
``` openssl rsa -pubout -in private.pem -out public.pem```
