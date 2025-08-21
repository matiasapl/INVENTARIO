import { useState } from "react";
import "/node_modules/bootstrap/dist/css/bootstrap.min.css";
import "./App.css";
import Login from "./components/Login/Index";

function App() {
  const [count, setCount] = useState(0);

  return (
    <>
      <Login />
    </>
  );
}

export default App;
