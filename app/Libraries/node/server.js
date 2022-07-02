import express from 'express';
import cors from 'cors';
import morgan from 'morgan';
import compression from 'compression';
import helmet from 'helmet';
import postRoutes from './routes/posts.js'; 

const app = express();
// dotenv.config();

app.use(express.json())
app.use(express.urlencoded({extended: true}))

app.use(cors());
app.use(morgan("dev"));
app.use(compression());
app.use(helmet());
app.disable("x-powered-by");

app.use('/api', postRoutes);
app.get('/', (req, res) => {
	res.send("Hello man!");
});

const PORT = process.env.PORT || 81;
app.listen(PORT, () => {
  console.log(`Server Running on Port: your-ip:${PORT}`);
});