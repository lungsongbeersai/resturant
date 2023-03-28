const Service=require('node-windows').Service
const svc=new Service({
    name:"nodeService",
    description:"This is out description",
    script:"D:\\xampp\\htdocs\\Resturant_v1\\server.js"
})

svc.on('install',function(){
    svc.start()
})

svc.install()