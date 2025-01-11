import React, { useContext } from "react";
import { BrowserRouter as Router, Routes, Route, NavLink } from "react-router-dom";
import { UserContext } from "./UserContext";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
import Home from "./components/Home";
import Login from "./components/Login";
import Register from "./components/Register";
import Products from "./components/Products";
import ProductPage from "./components/ProductPage";
import Account from "./components/Account";
import Cart from "./components/Cart";
import Favorites from "./components/Favorites";  // Import de la page Favorites
import "./components/css/App.css";

function App() {
    const { user } = useContext(UserContext);

    return (
        <Router>
            <div>
                <header className="navbar">
                    <h1 className="logo">L'Egregor</h1>
                    <nav className="nav-links">
                        <NavLink to="/" className={({ isActive }) => (isActive ? "active" : "")}>
                            Accueil
                        </NavLink>
                        <NavLink to="/products" className={({ isActive }) => (isActive ? "active" : "")}>
                            Produits
                        </NavLink>
                        {user ? (
                            <>
                                <NavLink to="/account" className={({ isActive }) => (isActive ? "active" : "")}>
                                    Mon compte
                                </NavLink>
                                <NavLink to="/favorites" className={({ isActive }) => (isActive ? "active" : "")}>
                                    Mes favoris
                                </NavLink>
                            </>
                        ) : (
                            <NavLink to="/login" className={({ isActive }) => (isActive ? "active" : "")}>
                                Connexion
                            </NavLink>
                        )}
                    </nav>
                    <NavLink to="/cart" className={({ isActive }) => (isActive ? "active" : "")}>
                        <FontAwesomeIcon icon={faCartShopping} />
                    </NavLink>
                </header>
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/login" element={<Login />} />
                    <Route path="/register" element={<Register />} />
                    <Route path="/products" element={<Products />} />
                    <Route path="/product/:id" element={<ProductPage />} />
                    {user && <Route path="/account" element={<Account />} />}
                    <Route path="/cart" element={<Cart />} />
                    {user && <Route path="/favorites" element={<Favorites />} />}
                </Routes>
            </div>
        </Router>
    );
}

export default App;
