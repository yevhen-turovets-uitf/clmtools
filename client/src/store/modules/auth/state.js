import Storage from '@/services/Storage';
import { emptyUser } from '@/services/Normalizer';

export default {
  user: Storage.getUser() ?? emptyUser(),
  isLoggedIn: Storage.hasToken(),
  token: Storage.getToken(),
  registration_user: null
};
