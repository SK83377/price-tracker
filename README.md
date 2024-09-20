Service for price-changing detection

tested on olx Poland 

main API point - subscribe takes 2 args (email and url of olx advert)

can be tested by 
curl -X POST http://localhost:8080/subscribe \
     -d "email=user@example.com" \
     -d "listing_url=https://www.olx.pl/d/oferta/rower-treningowy-spiningowy-kolo-24kg-regulowany-CID767-ID10UlWH.html"

For installations:
composer install

To run:
docker-compose up -d
