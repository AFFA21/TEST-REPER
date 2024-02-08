using MySqlConnector;


//CONFIG
var rating = "";
var compagny = "";
var jobtitle = "";
var salary = "";
var salaries = "";
var location = "";
var image = "";
double ratingForMatch;
double salaryFranc;

void ListenCSV()
{
    string cheminFichierCSV = @"D:\TEST_PROG\eval3-src\msig-prog-eval3-erp1-data.csv";

    using (MySqlConnection connection = new MySqlConnection("server=localhost;userid=root;password=root;database=db_inde;port=6033"))
    {
        connection.Open();

        foreach (string ligne in File.ReadAllLines(cheminFichierCSV))
        {
            AttributVariable(ligne);

            ratingForMatch = Convert.ToDouble(rating);

            if (ratingForMatch > 3.0)
            {
                string requeteInsertion = @"
                    INSERT INTO t_information 
                    (infRating, infCompagnyName, infJobTitle, infSalary, infSalaryFranc, infSalariesReported, infLocation, infImage)        
                    VALUES
                    (@rating, @compagny, @job, @salary, @salaryfranc, @salaries, @location, @image);
                ";

                using (MySqlCommand cmd = new MySqlCommand(requeteInsertion, new MySqlConnection("server=localhost;userid=root;password=root;database=db_inde;port=6033")))
                {
                    cmd.Connection = connection;
                    // Ajouter les paramètres
                    cmd.Parameters.AddWithValue("@rating", rating);
                    cmd.Parameters.AddWithValue("@compagny", compagny);
                    cmd.Parameters.AddWithValue("@job", jobtitle);
                    cmd.Parameters.AddWithValue("@salary", salary);
                    cmd.Parameters.AddWithValue("@salaryfranc", salaryFranc);
                    cmd.Parameters.AddWithValue("@salaries", salaries);
                    cmd.Parameters.AddWithValue("@location", location);
                    cmd.Parameters.AddWithValue("@image", image);

                    // Exécuter la commande
                    cmd.ExecuteNonQuery();
                }
            }
        }
    }
}

void AttributVariable(string ligne)
{
    var colonnes = ligne.Split(";");

    rating = colonnes[0];
    compagny = colonnes[1];
    jobtitle = colonnes[2].Replace(' ','-');
    salary = colonnes[3];
    salaries = colonnes[4];
    location = colonnes[5];
    salaryFranc = Convert.ToInt32(salary) * 0.011;

    if (jobtitle.ToLower().Contains("android"))
    {
        image = "droid.png";
    }
    else if (jobtitle.ToLower().Contains("python"))
    {
        image = "python.png";
    }
    else if (jobtitle.ToLower().Contains("ios"))
    {
        image = "mac.png";
    }
    else if (jobtitle.ToLower().Contains("sde"))
    {
        image = "dev.png";
    }
    else
    {
        image = "empty.png";
    }
}


// EXECUTION

ListenCSV();







