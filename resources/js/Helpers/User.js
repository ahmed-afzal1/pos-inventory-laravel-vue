import Token from './Token'
import AppStorage from './AppStorage'

class User {
    resAfterLogin(res) {
        const access_token = res.data.access_token;
        const username = res.data.name;

        if (Token.isValid(access_token)) {
            localStorage.setItem('user_id', res.data.user_id)
            AppStorage.store(access_token, username);
        }
    }

    isAdmin() {
        return !!(Number(localStorage.getItem('user_id') == 1))
    }

    hasToken() {
        const storeToken = localStorage.getItem('token');
        if (storeToken) {
            return Token.isValid(storeToken) ? true : false;
        }
        return false
    }

    loggedIn() {
        return this.hasToken();
    }

    loggedOut() {
        AppStorage.clear();
        localStorage.removeItem('user_id')
            // window.location = '/';
    }

    name() {
        if (this.loggedIn()) {
            return localStorage.getItem('user');
        }
    }

    id() {
        if (this.loggedIn()) {
            return Token;
        }
        return false
    }
}

export default User = new User();