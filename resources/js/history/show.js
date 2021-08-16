import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, project, history } = data;
    console.log(data);
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
                    href={`/projects/${project.id}/histories/${history.id}/edit`}
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
                                "Esta seguro que desea borrar la historia con todos sus tiquetes"
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
                    action={`/projects/${project.id}/histories/${history.id}`}
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
                    Nombre de la historia: {history.historyName}
                </li>
                <li className="list-group-item">
                    Creador de la historia: {history.userName}
                </li>
                <li className="list-group-item">
                    Email del creador: {history.userEmail}
                </li>
            </ul>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
