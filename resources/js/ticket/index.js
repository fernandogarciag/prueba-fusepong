import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, project, history, tickets } = data;
    const ticketsActive = tickets.filter((ticket) => ticket.state === 1);
    const ticketsProgress = tickets.filter((ticket) => ticket.state === 2);
    const ticketsFinished = tickets.filter((ticket) => ticket.state === 3);
    const displayTickets = (ticket, index) => (
        <li className="list-group-item d-flex align-items-center" key={index}>
            <a
                className="btn btn-info me-2"
                href={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}`}
            >
                Info
            </a>
            <span>{ticket.name}</span>
        </li>
    );
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <div className="mb-2">
                <a
                    href={`/projects/${project.id}/histories`}
                    type="button"
                    className="btn btn-primary me-2"
                >
                    Regresar
                </a>
                <a
                    className="btn btn-primary"
                    href={`/projects/${project.id}/histories/${history.id}/tickets/create`}
                >
                    Nuevo Tiquete
                </a>
            </div>
            <ul className="list-group mb-4">
                <li className="list-group-item bg-primary text-white">
                    Activo
                </li>
                {ticketsActive.map(displayTickets)}
            </ul>
            <ul className="list-group mb-4">
                <li className="list-group-item bg-success text-white">
                    En Proceso
                </li>
                {ticketsProgress.map(displayTickets)}
            </ul>
            <ul className="list-group">
                <li className="list-group-item bg-secondary text-white">
                    Finalizado
                </li>
                {ticketsFinished.map(displayTickets)}
            </ul>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
