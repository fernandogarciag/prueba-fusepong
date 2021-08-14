import React from "react";

const Container = ({ children, userName, auth, csrf, title }) => (
    <>
        <div id="app">
            <nav className="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div className="container">
                    <a className="navbar-brand" href="/">
                        Prueba-Fusepong
                    </a>
                    <button
                        className="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}"
                    >
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div
                        className="collapse navbar-collapse"
                        id="navbarSupportedContent"
                    >
                        {/* Left Side Of Navbar */}
                        <ul className="navbar-nav mr-auto"></ul>
                        {/* Right Side Of Navbar */}
                        <ul className="navbar-nav ml-auto">
                            {/* Authentication Links */}
                            {auth ? (
                                <>
                                    <li className="nav-item">
                                        <a
                                            className="nav-link"
                                            href="/logout"
                                            onClick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"
                                        >
                                            Logout
                                        </a>
                                        <form
                                            id="logout-form"
                                            action="/logout"
                                            method="POST"
                                            className="d-none"
                                        >
                                            <input
                                                type="hidden"
                                                name="_token"
                                                value={csrf}
                                            />
                                        </form>
                                    </li>
                                </>
                            ) : (
                                <>
                                    <li className="nav-item">
                                        <a className="nav-link" href="/login">
                                            Login
                                        </a>
                                    </li>
                                    <li className="nav-item">
                                        <a
                                            className="nav-link"
                                            href="/register"
                                        >
                                            Register
                                        </a>
                                    </li>
                                </>
                            )}
                        </ul>
                    </div>
                </div>
            </nav>

            <main className="py-4">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-md-8">
                            <div className="card">
                                <div className="card-header">{title}</div>
                                <div className="card-body">{children}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </>
);

export default Container;
