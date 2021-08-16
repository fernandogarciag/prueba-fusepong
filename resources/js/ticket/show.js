import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, project, history, ticket, deleteHistory } = data;
    const state = {
        1: "Activo",
        2: "En Proceso",
        3: "finalizado",
    };
    const deleteMessage = deleteHistory
        ? "\nSi lo borra, se borrara tambien la historia"
        : "";
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <div className="mb-2">
                <a
                    href={`/projects/${project.id}/histories/${history.id}/tickets`}
                    type="button"
                    className="btn btn-primary me-2"
                >
                    Regresar
                </a>
                <a
                    href={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}/edit`}
                    type="button"
                    className="btn btn-warning me-2"
                >
                    Editar
                </a>
                <a
                    className="btn btn-danger"
                    onClick={(e) => {
                        e.preventDefault();
                        if (
                            confirm(
                                `Esta seguro que desea borrar este tiquete.${deleteMessage}`
                            )
                        ) {
                            document.getElementById("destroy-form").submit();
                        }
                    }}
                >
                    Borrar
                </a>
                <form
                    id="destroy-form"
                    action={`/projects/${project.id}/histories/${history.id}/tickets/${ticket.id}`}
                    method="post"
                    className="d-none"
                >
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" value={csrf} />
                </form>
            </div>
            <ul className="list-group">
                <li className="list-group-item">
                    Nombre del projecto: {project.name}
                </li>
                <li className="list-group-item">
                    Nombre de la historia: {history.name}
                </li>
                <li className="list-group-item">
                    Nombre del tiquete: {ticket.name}
                </li>
                <li className="list-group-item">
                    Estado del tiquete: {state[ticket.state]}
                </li>
            </ul>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
