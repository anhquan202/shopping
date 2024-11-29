import logout from "./auth/logout";
import counter from "./components/counter";

export default function layout() {
  counter();
  logout();
}