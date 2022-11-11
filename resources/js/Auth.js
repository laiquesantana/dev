export default class Gate {

    constructor(user) {
        this.user = user;
    }

    roles() {
        return this.user.roles.map(role => role);
    }

    isAdmin() {

        return this.roles().includes('superAdmin');
    }

    permissions() {
        return this.user.permissions.map(permission => permission);
    }

    hasRole(roleName, superAdmin = true) {

        if (superAdmin === true && this.isAdmin()) {

            return true;
        } else {
            return this.roles().includes(roleName);
        }
    }

    can(permissionName, superAdmin = true) {
        if (superAdmin === true && this.isAdmin()) {
            return true;
        } else {

            return this.permissions().includes(permissionName);
        }
    }
    logo(){
        console.log(this.user);
    }
    getType() {
        switch (this.user.user.tipo) {
            case 'admin':
                return 'Administrador';
                break;
            default:
                return 'Consulta'
                break;
        }

    }



}
