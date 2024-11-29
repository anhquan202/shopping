import showHideLabel from '../components/showHideLabel';
import signin from '../auth/signin';

export default function login() {
  signin();
  showHideLabel();
}