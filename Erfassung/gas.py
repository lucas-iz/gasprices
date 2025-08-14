import requests
import json

basisURL = "https://creativecommons.tankerkoenig.de/json/"
myKey = "fde0edbb-6a01-0623-f32b-63cdc183832b"

myLat = str(54.3146)
myLng = str(10.1316)
myRad = str(5)
url = basisURL + "list.php?lat="+myLat+"&lng="+myLng+"&rad="+myRad+"&sort=dist&type=all&apikey="+myKey
res = requests.get(url)
result = json.loads(res.content)

print("// Status: " + result["status"])

if result['status'] == "ok":
    print("// " + str(len(result['stations'])) + " Tankstellen gefunden!")

    for station in result['stations']:
        print(station['name'] + "(" + station['place'] + ")")
        print("diesel / e5    / e10")
        print(str(station['diesel']) + "  / " + str(station['e5']) + " / " + str(station['e10']))
        print(station['id'])
        print("")

        requests.get("gasPriceUpload.php?id="+station['id']+"&diesel="+str(station['diesel'])+"&e5="+str(station['e5'])+"&e10="+str(station['e10']))
else:
    print("// Error: " + result['message'])
