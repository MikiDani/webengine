function AppComponent () {
    return (
        <div className="p-3 bg-info"><h1 className={'text-center'}>Helló Valakika6! Majd itt megy a feljesztés.</h1></div>
    );
}

ReactDOM.render(
    React.createElement(AppComponent),
    document.getElementById('app-container')
)