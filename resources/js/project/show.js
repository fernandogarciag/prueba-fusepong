import React from "react";
import ReactDOM from "react-dom";
import Layout from "../components/Layout";

const Root = ({ jsonData }) => {
    const data = JSON.parse(jsonData);
    const { auth, title, csrf, project } = data;
    console.log(data);
    return (
        <Layout auth={auth} csrf={csrf} title={title}>
            <div className=" mb-2">
                <a
                    href="/projects"
                    type="button"
                    className="btn btn-primary me-2"
                >
                    Regresar
                </a>
                <a
                    href={`/projects/${project.id}/edit`}
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
                                "Esta seguro que desea borrar el projecto con todos sus historias y tiquetes"
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
                    action={`/projects/${project.id}`}
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
            </ul>
        </Layout>
    );
};

if (document.getElementById("root")) {
    const data = document.getElementById("root").getAttribute("data");
    ReactDOM.render(<Root jsonData={data} />, document.getElementById("root"));
}
