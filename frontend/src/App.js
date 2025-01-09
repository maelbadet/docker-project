import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { UserProvider } from "./UserContext";
import Home from "./components/Home";
import Login from "./components/Login";
import Register from "./components/Register";
import Products from "./components/Products";
import ProductPage from "./components/ProductPage";

function App() {
    return (
        <UserProvider>
            <Router>
                <div>
                    <h1>Auth System</h1>
                    <Routes>
                        <Route path="/" element={<Home />} />
                        <Route path="/login" element={<Login />} />
                        <Route path="/register" element={<Register />} />
                        <Route path="/products" element={<Products />} />
                        <Route path="/product/:id" element={<ProductPage />} />
                    </Routes>
                </div>
            </Router>
        </UserProvider>
    );
}

export default App;
